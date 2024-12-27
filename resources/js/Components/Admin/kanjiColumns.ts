import { h } from "vue";
import { ColumnDef } from "@tanstack/vue-table";
import { ArrowUpDown } from "lucide-vue-next";
import { Kanji } from "@/types";
import { Button } from "@/Components/ui/button";
import { DropdownAction } from "@/Components/ui/data-table";

export const columns: ColumnDef<Kanji>[] = [
    {
        accessorKey: "literal",
        enablePinning: true,
        header: () => h("div", "Kanji"),
        cell: ({ row }) => {
            const literal: string = row.getValue("literal");

            return h("div", { class: "text-lg font-semibold" }, literal);
        },
    },
    {
        accessorKey: "meaning",
        header: ({ column }) =>
            h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => [
                    "Significado",
                    h(ArrowUpDown, { class: "ml-2 h-4 w-4" }),
                ],
            ),
        cell: ({ row }) => {
            const meaning: string = row.getValue("meaning");

            return h(
                "div",
                { class: "text-lg first-letter:capitalize ml-4" },
                meaning,
            );
        },
    },
    {
        accessorKey: "strokes",
        header: ({ column }) =>
            h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Trazos", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })],
            ),
        cell: ({ row }) => {
            const strokes: string = row.getValue("strokes");

            return h("div", { class: "text-lg ml-4" }, strokes);
        },
    },
    {
        accessorKey: "grade",
        header: ({ column }) =>
            h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Grado", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })],
            ),
        cell: ({ row }) => {
            const grade: string = row.getValue("grade");

            return h("div", { class: "text-lg ml-4" }, grade);
        },
    },
    {
        accessorKey: "heisig_index",
        header: ({ column }) =>
            h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Heisig", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })],
            ),
        cell: ({ row }) => {
            const heisig: string = row.getValue("heisig_index");

            return h("div", { class: "text-lg ml-4" }, heisig);
        },
    },
    {
        accessorKey: "wanikani_index",
        header: ({ column }) =>
            h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["WaniKani", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })],
            ),
        cell: ({ row }) => {
            const wanikani: string = row.getValue("wanikani_index");

            return h("div", { class: "text-lg ml-4" }, wanikani);
        },
    },
    {
        id: "actions",
        enablePinning: true,
        cell: ({ row }) => {
            const kanji = row.original;

            return h(
                "div",
                { class: "relative" },
                h(DropdownAction, {
                    id: kanji.id,
                    route: "kanjis",
                }),
            );
        },
    },
];
