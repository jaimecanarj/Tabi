import { h } from "vue";
import { ColumnDef } from "@tanstack/vue-table";
import { ArrowUpDown } from "lucide-vue-next";
import { User } from "@/types";
import { Button } from "@/Components/ui/button";
import { DropdownAction } from "@/Components/ui/data-table";

export const columns: ColumnDef<User>[] = [
    {
        accessorKey: "name",
        header: ({ column }) =>
            h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Nombre", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })],
            ),
        cell: ({ row }) => {
            const name: string = row.getValue("name");

            return h("div", { class: "text-lg ml-4" }, name);
        },
    },
    {
        accessorKey: "email",
        header: ({ column }) =>
            h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Email", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })],
            ),
        cell: ({ row }) => {
            const email: string = row.getValue("email");

            return h("div", { class: "text-lg ml-4" }, email);
        },
    },
    {
        accessorKey: "index",
        header: ({ column }) =>
            h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Índice", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })],
            ),
        cell: ({ row }) => {
            const index: string = row.getValue("index");

            return h(
                "div",
                { class: "text-lg first-letter:capitalize ml-4" },
                index,
            );
        },
    },
    {
        accessorKey: "daily_study",
        header: ({ column }) =>
            h(
                Button,
                {
                    variant: "ghost",
                    onClick: () =>
                        column.toggleSorting(column.getIsSorted() === "asc"),
                },
                () => ["Índice", h(ArrowUpDown, { class: "ml-2 h-4 w-4" })],
            ),
        cell: ({ row }) => {
            const dailyStudy: string = row.getValue("daily_study");

            return h(
                "div",
                { class: "text-lg first-letter:capitalize ml-4" },
                dailyStudy,
            );
        },
    },
    {
        id: "actions",
        enableHiding: false,
        cell: ({ row }) => {
            const user = row.original;

            return h(
                "div",
                { class: "relative" },
                h(DropdownAction, {
                    id: user.id,
                    route: "usuarios",
                }),
            );
        },
    },
];
