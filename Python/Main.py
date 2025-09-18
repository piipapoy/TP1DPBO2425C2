# Komentarnya sama aja sebenernya kaya di yang lain (mager nulis hehehe)

from Produk import Produk

def main():
    produk = [Produk() for _ in range(10)]
    jumlah = 0

    while True:
        print("Menu:")
        print("1. Tambah Produk")
        print("2. Tampilkan Semua Produk")
        print("3. Update Produk")
        print("4. Hapus Produk")
        print("0. Keluar")
        pilihan = int(input("Pilih menu: "))

        if pilihan == 1:
            if jumlah < 10:
                nama = input("Masukkan nama produk: ")
                merek = input("Masukkan merek produk: ")
                harga = int(input("Masukkan harga produk: "))
                stok = int(input("Masukkan stok produk: "))

                produk[jumlah].setNama(nama)
                produk[jumlah].setMerek(merek)
                produk[jumlah].setHarga(harga)
                produk[jumlah].setStok(stok)
                jumlah += 1
            else:
                print("Kapasitas produk penuh!")
        elif pilihan == 2:
            for i in range(jumlah):
                print(f"Produk ke-{i+1}:")
                produk[i].print()
                print()
        elif pilihan == 3:
            index = int(input(f"Masukkan nomor produk yang ingin diupdate (1-{jumlah}): "))
            if 1 <= index <= jumlah:
                nama = input("Masukkan nama produk baru: ")
                merek = input("Masukkan merek produk baru: ")
                harga = int(input("Masukkan harga produk baru: "))
                stok = int(input("Masukkan stok produk baru: "))

                produk[index - 1].setNama(nama)
                produk[index - 1].setMerek(merek)
                produk[index - 1].setHarga(harga)
                produk[index - 1].setStok(stok)
            else:
                print("Nomor produk tidak valid!")
        elif pilihan == 4:
            index = int(input(f"Masukkan nomor produk yang ingin dihapus (1-{jumlah}): "))
            if 1 <= index <= jumlah:
                for i in range(index - 1, jumlah - 1):
                    produk[i] = produk[i + 1]
                jumlah -= 1
                print("Produk berhasil dihapus.")
            else:
                print("Nomor produk tidak valid!")
        elif pilihan == 0:
            break
        else:
            print("Pilihan tidak valid!")

if __name__ == "__main__":
    main()