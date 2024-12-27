import { FunctionalComponent } from "vue";
import { LucideProps } from "lucide-vue-next";

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};

export interface User {
    id: number;
    name: string;
    email: string;
    index: string;
    daily_study: number;
    avatar: string;
    admin: boolean;
    created_at: string;
    updated_at: string;
}

export type Kanji = {
    id: number;
    literal: string;
    grade: number;
    strokes: number;
    meaning: string;
    frequency?: number;
    heisig_index: number;
    wanikani_index: number;
};

enum readType {
    onyomi = "onyomi",
    kunyomi = "kunyomi",
}

export type Reading = {
    id: number;
    kanji_id: number;
    reading: string;
    type: readType;
};

export type Meaning = {
    id: number;
    kanji_id: number;
    meaning: string;
};

export type Radical = {
    id: number;
    literal: string;
    meaning: string;
    strokes: number;
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

export type Study = {
    id: number;
    kanji_id: number;
    user_id: number;
    date: string;
    time: number;
    betaA: number;
    betaB: number;
    answer: number;
    successes: number;
    attempts: number;
};

export type KanjiLevel = {
    icon: FunctionalComponent<LucideProps, {}, any, {}>;
    name: string;
    color: string;
    bgColor: string;
    threshold: number;
};
