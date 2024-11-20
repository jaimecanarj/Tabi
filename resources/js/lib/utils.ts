import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";
import { Club, Crown, Diamond, Heart, Spade } from "lucide-vue-next";

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export const kanjiLevels = [
    {
        icon: Spade,
        title: "Aprendiz",
        color: "bg-levels-learner",
        threshold: 5,
    },
    {
        icon: Heart,
        title: "Conocedor",
        color: "bg-levels-educated",
        threshold: 10,
    },
    {
        icon: Club,
        title: "Versado",
        color: "bg-levels-proficient",
        threshold: 30,
    },
    {
        icon: Diamond,
        title: "Experto",
        color: "bg-levels-expert",
        threshold: 90,
    },
    {
        icon: Crown,
        title: "Maestro",
        color: "bg-levels-master",
        threshold: Infinity,
    },
];
