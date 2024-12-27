<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import ProfileSettings from "@/Components/Settings/ProfileSettings.vue";
import PasswordSettings from "@/Components/Settings/PasswordSettings.vue";
import OtherSettings from "@/Components/Settings/OtherSettings.vue";
</script>

<template>
    <Head title="Configuración" />
    <MainLayout />
    <main class="container mt-12">
        <ProfileSettings />
        <PasswordSettings />
        <OtherSettings />
    </main>
</template>
