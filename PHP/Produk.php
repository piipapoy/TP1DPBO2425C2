<?php

class Produk {
    public $nama;
    public $merek;
    public $harga;
    public $stok;
    public $gambarPath;

    public function __construct($nama = "", $merek = "", $harga = 0, $stok = 0, $gambarPath = "") {
        $this->nama = (string)$nama;
        $this->merek = (string)$merek;
        $this->harga = (int)$harga;
        $this->stok = (int)$stok;
        $this->gambarPath = (string)$gambarPath;
    }

    public function toArray() {
        return [
            'nama' => $this->nama,
            'merek' => $this->merek,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'gambarPath' => $this->gambarPath
        ];
    }

    public static function fromArray($arr) {
        return new Produk(
            isset($arr['nama']) ? $arr['nama'] : "",
            isset($arr['merek']) ? $arr['merek'] : "",
            isset($arr['harga']) ? $arr['harga'] : 0,
            isset($arr['stok']) ? $arr['stok'] : 0,
            isset($arr['gambarPath']) ? $arr['gambarPath'] : ""
        );
    }
}
