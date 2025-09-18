import java.util.Scanner; // import Scanner

public class Main {
    public static void main(String[] args) {
        Produk[] produk = new Produk[10]; // Array untuk menyimpan produk
        int jumlah = 0; // Jumlah produk yang ada
        Scanner sc = new Scanner(System.in); // Scanner untuk input

        while (true) { // Loop menu
            // Tampilkan menu
            System.out.println("Menu:");
            System.out.println("1. Tambah Produk");
            System.out.println("2. Tampilkan Semua Produk");
            System.out.println("3. Update Produk");
            System.out.println("4. Hapus Produk");
            System.out.println("0. Keluar");
            System.out.print("Pilih menu: ");
            int pilihan = sc.nextInt(); // Baca pilihan
            sc.nextLine(); // Bersihkan newline

            // Semua if untuk pilihan menu
            if (pilihan == 1) {// Tambah produk
                if (jumlah < 10) { // Cek kapasitas
                    // Input atribut produk
                    System.out.print("Masukkan nama produk: ");
                    String nama = sc.nextLine();
                    System.out.print("Masukkan merek produk: ");
                    String merek = sc.nextLine();
                    System.out.print("Masukkan harga produk: ");
                    int harga = sc.nextInt();
                    System.out.print("Masukkan stok produk: ");
                    int stok = sc.nextInt();
                    sc.nextLine();

                    // Set atribut produk ke array
                    produk[jumlah] = new Produk();
                    produk[jumlah].setNama(nama);
                    produk[jumlah].setMerek(merek);
                    produk[jumlah].setHarga(harga);
                    produk[jumlah].setStok(stok);

                    jumlah++; // Tambah jumlah produk
                } else { // Kalau penuh
                    System.out.println("Kapasitas produk penuh!");
                }
            } else if (pilihan == 2) { // Tampilkan semua produk
                // Loop untuk print semua produk
                for (int i = 0; i < jumlah; i++) {
                    System.out.println("Produk ke-" + (i + 1) + ":");
                    produk[i].print();
                    System.out.println();
                }
            } else if (pilihan == 3) { // Update produk
                // Input nomor produk yang ingin diupdate
                System.out.print("Masukkan nomor produk yang ingin diupdate (1-" + jumlah + "): ");
                int index = sc.nextInt();
                sc.nextLine();
                if (index >= 1 && index <= jumlah) { // Cek index valid
                    System.out.print("Masukkan nama produk baru: ");
                    String nama = sc.nextLine();
                    System.out.print("Masukkan merek produk baru: ");
                    String merek = sc.nextLine();
                    System.out.print("Masukkan harga produk baru: ");
                    int harga = sc.nextInt();
                    System.out.print("Masukkan stok produk baru: ");
                    int stok = sc.nextInt();
                    sc.nextLine();

                    // Update atribut produk
                    produk[index - 1].setNama(nama);
                    produk[index - 1].setMerek(merek);
                    produk[index - 1].setHarga(harga);
                    produk[index - 1].setStok(stok);
                } else { // Kalau index tidak valid
                    System.out.println("Nomor produk tidak valid!");
                }
            } else if (pilihan == 4) { // Hapus produk
                // Input nomor produk yang ingin dihapus
                System.out.print("Masukkan nomor produk yang ingin dihapus (1-" + jumlah + "): ");
                int index = sc.nextInt();
                sc.nextLine();
                if (index >= 1 && index <= jumlah) { // Cek index valid
                    // Geser produk setelah index ke kiri
                    for (int i = index - 1; i < jumlah - 1; i++) {
                        produk[i] = produk[i + 1];
                    }
                    produk[jumlah - 1] = null; // Hapus akhir array
                    jumlah--; // Kurangi jumlah produk
                    System.out.println("Produk berhasil dihapus.");
                } else {
                    System.out.println("Nomor produk tidak valid!");
                }
            } else if (pilihan == 0) { // Keluar
                break;
            } else { // Kalau pilihan bukan antara 0-4
                System.out.println("Pilihan tidak valid!");
            }
        }

        sc.close();
    }
}
