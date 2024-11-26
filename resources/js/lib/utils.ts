import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";
import { Club, Crown, Diamond, Heart, Spade } from "lucide-vue-next";
import { KanjiLevel } from "@/lib/types";

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

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
