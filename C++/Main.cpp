#include "Produk.cpp"

int main() {
    Produk produk[10]; // Array untuk menyimpan 10 produk
    int jumlah = 0; // Jumlah produk yang ada
    int pilihan; // Pilihan menu

    while (true) { // Looping menu
        // Print menu
        cout << "Menu:" << endl;
        cout << "1. Tambah Produk" << endl;
        cout << "2. Tampilkan Semua Produk" << endl;
        cout << "3. Update Produk" << endl;
        cout << "4. Hapus Produk" << endl;
        cout << "0. Keluar" << endl;
        cout << "Pilih menu: ";
        cin >> pilihan; // Input pilihan

        // Semua if untuk setiap pilihan menu
        if (pilihan == 1) { // Tambah Produk
            if (jumlah < 10) { // Cek kapasitas array
                // Atribut produk
                string nama, merek;
                int harga, stok;

                // Input atribut produk
                cout << "Masukkan nama produk: ";
                cin >> nama;
                cout << "Masukkan merek produk: ";
                cin >> merek;
                cout << "Masukkan harga produk: ";
                cin >> harga;
                cout << "Masukkan stok produk: ";
                cin >> stok;

                // Set atribut produk ke array
                produk[jumlah].setNama(nama);
                produk[jumlah].setMerek(merek);
                produk[jumlah].setHarga(harga);
                produk[jumlah].setStok(stok);
                jumlah++; // Tambah jumlah produk
            } else { // Kalau penuh
                cout << "Kapasitas produk penuh!" << endl;
            }
        } else if (pilihan == 2) { // Tampilkan Semua Produk
            // Loop untuk print semua produk
            for (int i = 0; i < jumlah; i++) {
                cout << "Produk ke-" << (i + 1) << ":" << endl;
                produk[i].print();
                cout << endl;
            }
        } else if (pilihan == 3) { // Update Produk
            int index; // Index produk yang ingin diupdate
            cout << "Masukkan nomor produk yang ingin diupdate (1-" << jumlah << "): ";
            cin >> index;
            if (index >= 1 && index <= jumlah) { // Cek index valid
                // Atribut produk baru
                string nama, merek;
                int harga, stok;

                // Input atribut produk baru
                cout << "Masukkan nama produk baru: ";
                cin >> nama;
                cout << "Masukkan merek produk baru: ";
                cin >> merek;
                cout << "Masukkan harga produk baru: ";
                cin >> harga;
                cout << "Masukkan stok produk baru: ";
                cin >> stok;

                // Update atribut produk di array
                produk[index - 1].setNama(nama);
                produk[index - 1].setMerek(merek);
                produk[index - 1].setHarga(harga);
                produk[index - 1].setStok(stok);
            } else { // Kalau index tidak valid
                cout << "Nomor produk tidak valid!" << endl;
            }
        } else if (pilihan == 4) { // Hapus Produk
            int index; // Index produk yang ingin dihapus
            cout << "Masukkan nomor produk yang ingin dihapus (1-" << jumlah << "): ";
            cin >> index;
            if (index >= 1 && index <= jumlah) { // Cek index valid
                // Geser semua produk setelah index ke kiri
                for (int i = index - 1; i < jumlah - 1; i++) {
                    produk[i] = produk[i + 1];
                }
                jumlah--; // Kurangi jumlah produk
                cout << "Produk berhasil dihapus." << endl;
            } else { // Kalau index tidak valid
                cout << "Nomor produk tidak valid!" << endl;
            }
        } else if (pilihan == 0) { // Keluar
            break;
        } else { // Kalau pilihan bukan antara 0-4
            cout << "Pilihan tidak valid!" << endl;
        }
    }

}