export type Kanji = {
    id: number;
    literal: string;
    grado: number;
    trazos: number;
    significado: string;
    frecuencia?: number;
    indice_escolar: number;
    indice_heisig: number;
    indice_wanikani: number;
};

enum tipoLectura {
    onyomi = "onyomi",
    kunyomi = "kunyomi",
}

export type Lectura = {
    id: number;
    kanji_id: number;
    lectura: string;
    tipo: tipoLectura;
};

export type Significado = {
    id: number;
    kanji_id: number;
    significado: string;
};

export type Radical = {
    id: number;
    literal: string;
    significado: string;
    trazos: number;
};
