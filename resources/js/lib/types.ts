import { FunctionalComponent } from "vue";
import { LucideProps } from "lucide-vue-next";

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

export type Answer = {
    userAnswer: string;
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

export type Usuario = {
    id: number;
    name: string;
    email: string;
    indice: string;
    estudio_diario: number;
    avatar: string;
    created_at: string;
    updated_at: string;
};

export type KanjiLevel = {
    icon: FunctionalComponent<LucideProps, {}, any, {}>;
    name: string;
    color: string;
    bgColor: string;
    threshold: number;
};
