# Komentarnya sama aja sebenernya kaya di yang lain (mager nulis hehehe)

class Produk:
    def __init__(self, nama: str = "", merek: str = "", harga: int = 0, stok: int = 0):
        self.nama = str(nama)
        self.merek = str(merek)
        self.harga = int(harga)
        self.stok = int(stok)

    def setNama(self, nama: str) -> None:
        self.nama = str(nama)

    def getNama(self) -> str:
        return self.nama

    def setMerek(self, merek: str) -> None:
        self.merek = str(merek)

    def getMerek(self) -> str:
        return self.merek

    def setHarga(self, harga: int) -> None:
        self.harga = int(harga)

    def getHarga(self) -> int:
        return self.harga

    def setStok(self, stok: int) -> None:
        self.stok = int(stok)

    def getStok(self) -> int:
        return self.stok

    def print(self) -> None:
        print("Nama:", self.nama)
        print("Merek:", self.merek)
        print("Harga:", self.harga)
        print("Stok:", self.stok)
