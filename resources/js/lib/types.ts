type Kanji = {
    id: number;
    literal: string;
    grado: number;
    trazos: number;
    frecuencia?: number;
};

enum tipoLectura {
    onyomi = "onyomi",
    kunyomi = "kunyomi",
}

type Lectura = {
    id: number;
    kanji_id: number;
    lectura: string;
    tipo: tipoLectura;
};

type Significado = {
    id: number;
    kanji_id: number;
    significado: string;
};
