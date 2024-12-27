import { h } from "vue";
import { ColumnDef } from "@tanstack/vue-table";
import { ArrowUpDown } from "lucide-vue-next";
import { Radical } from "@/types";
import { Button } from "@/Components/ui/button";
import { DropdownAction } from "@/Components/ui/data-table";

export const columns: ColumnDef<Radical>[] = [
    {
        accessorKey: "literal",
        header: () => h("div", "Radical"),
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
        id: "actions",
        enableHiding: false,
        cell: ({ row }) => {
            const radical = row.original;

            return h(
                "div",
                { class: "relative" },
                h(DropdownAction, {
                    id: radical.id,
                    route: "radicales",
                }),
            );
        },
    },
];
