<template>
    <Head title="Tambah Role" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah Role
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Nama Role
                                </label>
                                <input
                                    type="text"
                                    v-model="form.name"
                                    placeholder="Masukkan nama role"
                                    class="mt-1 w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                                    required
                                />
                            </div>

                            <div class="flex justify-end">
                                <Link
                                    :href="route('roles')"
                                    class="mr-4 rounded bg-gray-200 px-4 py-2 hover:bg-gray-300"
                                >
                                    Batal
                                </Link>
                                <button
                                    type="submit"
                                    class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                                >
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
});

function submit() {
    form.post(route("roles.store"), {
        preserveScroll: true,
    });
}
</script>
