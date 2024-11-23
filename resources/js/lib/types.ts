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

export type Pagination = {
    data: Kanji[] | Radical[];
    current_page: number;
    per_page: number;
    total: number;
};

export type Filters = {
    page?: number;
    search?: string;
    strokes?: string;
    grade?: string;
    sortCategory?: string;
    sortOrder?: string;
};

export type Question = {
    answer: string;
    answered: boolean;
    answerResult: boolean | undefined;
};

export type Estudio = {
    id: number;
    kanji_id: number;
    user_id: number;
    fecha: string;
    tiempo: number;
    betaA: number;
    betaB: number;
    respuesta: number;
    aciertos: number;
    intentos: number;
};
