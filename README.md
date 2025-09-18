# TP1DPBO2425C2
TP1 DPBO

Saya M. Raffa Mizanul Insan dengan NIM 2409119
mengerjakan TP 1 dalam mata kuliah Desain Pemrograman Berorientasi Objek
untuk keberkahan-Nya maka saya tidak akan melakukan kecurangan
seperti yang telah di spesifikasikan Aamiin.

Penjelasan desain:

Class Produk: bertanggung jawab menyimpan data satu produk dan validasi kecil.
Atribut (privat): id, nama, merek, harga, stok
Method (publik): get...(), set...(), toString() / print(), isValid()
Main program: loop menu yang membaca input dan memanggil method pada objek/array produk.
Encapsulation: atribut private -> hanya dapat diubah lewat set yang melakukan validasi (mis. harga >= 0).

Flow kode:

Program mulai, buat array/list kosong produkList dan nextId = 1.
Tampilkan menu: Tambah, List, Update, Hapus, Keluar.
Untuk tambah: baca input -> buat Produk baru -> validasi via set -> set id = nextId++ -> masukkan ke produkList.
Untuk list: loop produkList dan panggil print() tiap Produk.
Untuk update: minta id -> cari produk → jika ada, minta input baru -> panggil set...() untuk setiap atribut -> beri pesan sukses.
Untuk hapus: minta id -> hapus dari produkList jika ditemukan.
Kembali ke menu sampai pilih Keluar.
