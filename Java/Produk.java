public class Produk { // Bikin class Produk
    // Atribut
    private String nama;
    private String merek;
    private int harga;
    private int stok;

    // Konstruktor default
    public Produk() {
        this.nama = "";
        this.merek = "";
        this.harga = 0;
        this.stok = 0;
    }

    // Konstruktor dengan parameter
    public Produk(String nama, String merek, int harga, int stok) {
        this.nama = nama;
        this.merek = merek;
        this.harga = harga;
        this.stok = stok;
    }

    // Setter dan Getter untuk setiap atribut

    public void setNama(String nama) {
        this.nama = nama;
    }

    public String getNama() {
        return this.nama;
    }

    public void setMerek(String merek) {
        this.merek = merek;
    }

    public String getMerek() {
        return this.merek;
    }

    public void setHarga(int harga) {
        this.harga = harga;
    }

    public int getHarga() {
        return this.harga;
    }

    public void setStok(int stok) {
        this.stok = stok;
    }

    public int getStok() {
        return this.stok;
    }

    // Method untuk print produk
    public void print() {
        System.out.println("Nama: " + this.nama);
        System.out.println("Merek: " + this.merek);
        System.out.println("Harga: " + this.harga);
        System.out.println("Stok: " + this.stok);
    }
}