<template>
    <Head title="Tambah User" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Tambah User
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="bg-white p-6 shadow-md sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Nama</label
                            >
                            <input
                                v-model="form.name"
                                type="text"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors.name"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Email</label
                            >
                            <input
                                v-model="form.email"
                                type="email"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors.email"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.email }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Password</label
                            >
                            <input
                                v-model="form.password"
                                type="password"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            />
                            <div
                                v-if="form.errors.password"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.password }}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Role</label
                            >
                            <select
                                v-model="form.role_id"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            >
                                <option value="">Pilih Role</option>
                                <option
                                    v-for="role in roles"
                                    :key="role.id"
                                    :value="role.id"
                                >
                                    {{ role.name }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.role_id"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.role_id }}
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <Link
                                href="/master/users"
                                class="mr-4 rounded px-4 py-2 text-sm text-gray-600 hover:underline"
                                >Batal</Link
                            >
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
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    roles: Array,
});

const form = useForm({
    name: "",
    email: "",
    password: "",
    role_id: "",
});

function submit() {
    form.post(route("users.store"));
}
</script>
