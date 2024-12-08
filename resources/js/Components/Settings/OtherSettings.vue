<script setup lang="ts">
import { Button } from "@/Components/ui/button";
import axios from "axios";
import { toast } from "@/Components/ui/toast";
import { router } from "@inertiajs/vue3";
import {
    AlertDialog,
    AlertDialogTrigger,
    AlertDialogContent,
    AlertDialogHeader,
    AlertDialogCancel,
    AlertDialogTitle,
    AlertDialogFooter,
    AlertDialogDescription,
    AlertDialogAction,
} from "@/Components/ui/alert-dialog";

const resetProgress = () => {
    axios.post("/reset-progress").then(() => {
        toast({
            title: "Progreso reiniciado",
        });
    });
};

const deleteAccount = () => {
    router.delete("/user");
};
</script>

<template>
    <div
        class="mt-10 flex flex-col items-center rounded-md bg-card p-5 md:items-start"
    >
        <h2 class="text-3xl font-semibold">Otras opciones</h2>
        <div class="mt-6 flex flex-col gap-8 md:flex-row md:gap-16">
            <div>
                <h3 class="text-xl">Reiniciar progreso</h3>
                <p class="mt-1 text-muted-foreground">
                    Esto eliminará todo tu progreso.
                </p>
                <AlertDialog>
                    <AlertDialogTrigger as-child>
                        <Button variant="destructive" class="mt-4 w-60 sm:w-72">
                            Reiniciar
                        </Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>
                                ¿Estás seguro?
                            </AlertDialogTitle>
                            <AlertDialogDescription>
                                Esta acción no puede ser deshecha. Tu progreso
                                será permanentemente borrado.
                            </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                            <AlertDialogCancel>Cancelar</AlertDialogCancel>
                            <AlertDialogAction as-child>
                                <form @submit.prevent="resetProgress">
                                    <Button type="submit"> Confirmar </Button>
                                </form>
                            </AlertDialogAction>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </div>
            <div>
                <h3 class="text-xl">Eliminar cuenta</h3>
                <p class="mt-1 text-muted-foreground">Perderás tu cuenta.</p>
                <AlertDialog>
                    <AlertDialogTrigger as-child>
                        <Button variant="destructive" class="mt-4 w-60 sm:w-72">
                            Eliminar
                        </Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>
                                ¿Estás seguro?
                            </AlertDialogTitle>
                            <AlertDialogDescription>
                                Esta acción no puede ser deshecha. Tu cuenta
                                será permanentemente borrada.
                            </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                            <AlertDialogCancel>Cancelar</AlertDialogCancel>
                            <form @submit.prevent="deleteAccount">
                                <Button type="submit"> Confirmar </Button>
                            </form>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </div>
        </div>
    </div>
</template>
