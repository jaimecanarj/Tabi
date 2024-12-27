<script setup lang="ts" generic="TData">
import { ref } from "vue";
import axios from "axios";
import type { ColumnDef } from "@tanstack/vue-table";
import { User, Kanji, Radical } from "@/types";
import MainLayout from "@/Layouts/MainLayout.vue";
import InfoCard from "@/Components/Admin/InfoCard.vue";
import { columns as kanjiColumns } from "@/Components/Admin/kanjiColumns";
import { columns as radicalColumns } from "@/Components/Admin/radicalColumns";
import { columns as userColumns } from "@/Components/Admin/userColumns";
import { DataTable } from "@/Components/ui/data-table";

defineProps<{ kanjis: number; radicals: number; users: number }>();

//Datos a administrar
let data = ref<Kanji[] | Radical[] | User[]>([]);
let columns = ref<
    (ColumnDef<Kanji> | ColumnDef<Radical> | ColumnDef<User>)[] | null
>(null);
let name = ref<string>("");

const fetchData = (type: string) => {
    axios.get(`/admin/${type}`).then((res) => {
        data.value = res.data;
        switch (type) {
            case "kanjis":
                columns.value = kanjiColumns;
                name.value = "kanjis";
                break;
            case "radicals":
                columns.value = radicalColumns;
                name.value = "radicales";
                break;
            case "users":
                columns.value = userColumns;
                name.value = "usuarios";
                break;
        }
    });
};
</script>

<template>
    <MainLayout />
    <main class="container my-12">
        <div class="flex flex-col justify-between gap-7 md:flex-row">
            <InfoCard
                :item="kanjis"
                kanjis="漢字"
                name="kanji"
                plural="s"
                @click="fetchData('kanjis')"
            />
            <InfoCard
                :item="radicals"
                kanjis="部首"
                name="radical"
                plural="es"
                @click="fetchData('radicals')"
            />
            <InfoCard
                :item="users"
                kanjis="ユーザー"
                name="usuario"
                plural="s"
                @click="fetchData('users')"
            />
        </div>
        <div class="mt-8" v-if="data.length > 0 && columns">
            <DataTable
                :key="name"
                :columns="columns as any"
                :data="data as any"
                :name="name"
            />
        </div>
    </main>
</template>
