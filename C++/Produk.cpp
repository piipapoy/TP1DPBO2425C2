#include <iostream>
#include <string>
using namespace std;

class Produk { // Bikin class Produk
    private: // Atribut private
        string nama;
        string merek;
        int harga;
        int stok;

    public: // Method public
        Produk() { // Konstruktor default
        }

        Produk(string nama, string merek, int harga, int stok) { // Konstruktor dengan parameter
            // this-> untuk membedakan atribut dan parameter
            this->nama = nama;
            this->merek = merek; 
            this->harga = harga;
            this->stok = stok;
        }

        // Setter dan Getter untuk setiap atribut

        void setNama(string nama) {
            this->nama = nama;
        }
        string getNama() {
            return this->nama;
        }

        void setMerek(string merek) {
            this->merek = merek;
        }
        string getMerek() {
            return this->merek;
        }

        void setHarga(int harga) {
            this->harga = harga;
        }
        int getHarga() {
            return this->harga;
        }

        void setStok(int stok) {
            this->stok = stok;
        }
        int getStok() {
            return this->stok;
        }

        void print() { // Method untuk print produk
            cout << "Nama: " << this->nama << endl;
            cout << "Merek: " << this->merek << endl;
            cout << "Harga: " << this->harga << endl;
            cout << "Stok: " << this->stok << endl;
        }

        ~Produk() { // Destruktor
        }
};