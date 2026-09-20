<?php
    // Class blueprint untuk entitas Sesi Tayang Bioskop
    class SesiTayang {
        // Enkapsulasi property entitas
        private string $id_sesi;
        private string $judul_film;
        private string $jadwal;
        private float $harga;
        private string $gambar;

        // Constructor untuk mempopulasikan state awal
        public function __construct(string $id_sesi, string $judul_film, string $jadwal, float $harga, string $gambar)
        {
            $this->id_sesi = $id_sesi; 
            $this->judul_film = $judul_film; 
            $this->jadwal = $jadwal; 
            $this->harga = $harga; 
            $this->gambar = $gambar; 
        }

        // --- Accessor (Getter) ---
        public function getId(): string
        {
            return $this->id_sesi; 
        }

        public function getJudul(): string
        {
            return $this->judul_film; 
        }

        public function getJadwal(): string
        {
            return $this->jadwal; 
        }

        public function getHarga(): float
        {
            return $this->harga; 
        }

        public function getGambar(): string
        {
            return $this->gambar; 
        }

        // --- Mutator (Setter) ---
        public function setId(string $id_sesi): void
        {
            $this->id_sesi = $id_sesi; 
        }

        public function setJudul(string $judul_film): void
        {
            $this->judul_film = $judul_film; 
        }

        public function setJadwal(string $jadwal): void
        {
            $this->jadwal = $jadwal; 
        }

        // Setter harga yang memvalidasi integritas numerik
        public function setHarga(float $harga): void
        {
            if ($harga > 0) {
                $this->harga = $harga; 
            } else {
                echo "Error: Harga tidak boleh bernilai kurang dari atau sama dengan 0."; 
            }
        }

        public function setGambar(string $gambar): void
        {
            $this->gambar = $gambar; 
        }

        // Mencetak state objek untuk testing (CLI/Debugging)
        public function tampilkanData(): void
        {
            echo "ID Sesi: " . $this->getId() . "<br>";
            echo "Judul Film: " . $this->getJudul() . "<br>";
            echo "Jadwal: " . $this->getJadwal() . "<br>";
            echo "Harga: " . $this->getHarga() . "<br>";
            echo "Gambar: " . $this->getGambar() . "<br>";
        }
    }