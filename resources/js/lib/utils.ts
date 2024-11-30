import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";
import {
    Clock1,
    Clock10,
    Clock11,
    Clock12,
    Clock2,
    Clock3,
    Clock4,
    Clock5,
    Clock6,
    Clock7,
    Clock8,
    Clock9,
    Club,
    Crown,
    Diamond,
    Heart,
    Spade,
} from "lucide-vue-next";
import { KanjiLevel } from "@/lib/types";
import moment from "moment/moment";

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export const momentLocale = () => {
    moment.updateLocale("es", {
        months: "Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre".split(
            "_",
        ),
        monthsShort: "Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dic".split(
            "_",
        ),
    });
};

export const kanjiLevels: KanjiLevel[] = [
    {
        icon: Spade, //Sin uso
        name: "Nuevos",
        color: "bg-zinc-500",
        threshold: 0,
    },
    {
        icon: Spade,
        name: "Aprendiz",
        color: "bg-levels-learner",
        threshold: 5,
    },
    {
        icon: Heart,
        name: "Conocedor",
        color: "bg-levels-educated",
        threshold: 10,
    },
    {
        icon: Club,
        name: "Versado",
        color: "bg-levels-proficient",
        threshold: 30,
    },
    {
        icon: Diamond,
        name: "Experto",
        color: "bg-levels-expert",
        threshold: 90,
    },
    {
        icon: Crown,
        name: "Maestro",
        color: "bg-levels-master",
        threshold: Infinity,
    },
];

export const hourIcons = [
    Clock12,
    Clock1,
    Clock2,
    Clock3,
    Clock4,
    Clock5,
    Clock6,
    Clock7,
    Clock8,
    Clock9,
    Clock10,
    Clock11,
    Clock12,
    Clock1,
    Clock2,
    Clock3,
    Clock4,
    Clock5,
    Clock6,
    Clock7,
    Clock8,
    Clock9,
    Clock10,
    Clock11,
];
