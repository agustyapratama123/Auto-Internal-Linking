<?php 

class Codewpx_Link_Processor {
    public function find_and_replace_links($content) {
        // Ambil daftar keyword dari database
        $keywords = get_option('codewpx_ail_keywords', []);
        if (empty($keywords)) return $content;

        // Pattern untuk mengecualikan konten dalam tag tertentu
        $exclude_pattern = '/<(a|code|pre|script|style)[^>]*>.*?<\/\1>/is';
        
        // Temukan semua area yang harus di-exclude
        preg_match_all($exclude_pattern, $content, $excluded_matches, PREG_OFFSET_CAPTURE);
        $excluded_zones = $this->get_excluded_zones($excluded_matches);

        // Proses konten per paragraf
        return preg_replace_callback('/<p>.*?<\/p>/is', function($paragraph) use ($keywords, $excluded_zones) {
            return $this->process_paragraph($paragraph[0], $keywords, $excluded_zones);
        }, $content);
    }

    private function get_excluded_zones($matches) {
        // Buat array untuk menyimpan zona yang harus di-exclude
        $zones = [];
        
        foreach ($matches[0] as $match) {
            // Simpan posisi awal dan akhir dari zona excluded
            $zones[] = [
                'start' => $match[1], // Posisi awal tag
                'end' => $match[1] + strlen($match[0]) // Posisi akhir tag
            ];
        }
        return $zones;
    }

    private function process_paragraph($paragraph, $keywords, $excluded_zones) {
        $offset = 0; // Posisi awal pemrosesan
        $processed = ''; // Variabel untuk menyimpan hasil
        $paragraph_length = strlen($paragraph);
        
        while ($offset < $paragraph_length) {
            // Cek jika posisi saat ini berada dalam excluded zone
            $in_excluded_zone = false;
            foreach ($excluded_zones as $zone) {
                if ($offset >= $zone['start'] && $offset < $zone['end']) {
                    $in_excluded_zone = true;
                    $offset = $zone['end']; // Skip ke akhir zona excluded
                    break;
                }
            }
            
            // Jika berada di zona excluded, lanjutkan ke karakter berikutnya
            if ($in_excluded_zone) {
                continue;
            }

            // Cari keyword yang cocok
            $found = false;
            foreach ($keywords as $keyword => $url) {
                // Buat pattern regex untuk keyword
                $pattern = '/\b' . preg_quote($keyword, '/') . '\b/i';
                
                // Cari kemunculan keyword
                if (preg_match($pattern, $paragraph, $matches, PREG_OFFSET_CAPTURE, $offset)) {
                    $pos = $matches[0][1]; // Posisi keyword
                    $length = strlen($matches[0][0]); // Panjang keyword
                    
                    // Ganti hanya kemunculan pertama di paragraf ini
                    $processed .= substr($paragraph, $offset, $pos - $offset); // Teks sebelum keyword
                    $processed .= '<a href="' . esc_url($url) . '" class="codewpx-internal-link">' . $matches[0][0] . '</a>'; // Keyword dengan link
                    $offset = $pos + $length; // Geser offset
                    $found = true;
                    break;
                }
            }
            
            // Jika tidak ada keyword yang cocok, tambahkan sisa teks
            if (!$found) {
                $processed .= substr($paragraph, $offset);
                break;
            }
        }
        
        // Kembalikan hasil atau paragraf asli jika tidak ada perubahan
        return $processed ?: $paragraph;
    }
}