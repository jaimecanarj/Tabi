import { type ClassValue, clsx } from "clsx";
import { twMerge } from "tailwind-merge";
import { Dice1, Dice2, Dice3, Dice4, Dice5 } from "lucide-vue-next";

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export const kanjiLevels = [
    {
        icon: Dice1,
        title: "Aprendiz",
        color: "bg-levels-learner",
        threshold: 5,
    },
    {
        icon: Dice2,
        title: "Conocedor",
        color: "bg-levels-educated",
        threshold: 10,
    },
    {
        icon: Dice3,
        title: "Versado",
        color: "bg-levels-proficient",
        threshold: 30,
    },
    { icon: Dice4, title: "Experto", color: "bg-levels-expert", threshold: 90 },
    {
        icon: Dice5,
        title: "Maestro",
        color: "bg-levels-master",
        threshold: Infinity,
    },
];
