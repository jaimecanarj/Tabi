export interface User {
    id: number;
    name: string;
    email: string;
    indice: string;
    estudio_diario: number;
    avatar: string;
    admin: boolean;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};
