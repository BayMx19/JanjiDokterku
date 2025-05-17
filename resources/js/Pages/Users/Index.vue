<template>
    <Head title="Master Users" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Master Users
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Tombol di kanan -->
                        <div class="mb-4 flex justify-end">
                            <Link
                                href="/master/users/create"
                                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                <i class="fas fa-plus mr-2"></i>Tambah User
                            </Link>
                        </div>

                        <div class="overflow-x-auto">
                            <table
                                class="w-full table-auto border-collapse border border-gray-200"
                            >
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Nama
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Email
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Role
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="user in props.users.data"
                                        :key="user.id"
                                        class="even:bg-gray-50"
                                    >
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ user.name }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ user.email }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ user.role.name }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            <div
                                                class="flex items-center space-x-2"
                                            >
                                                <Link
                                                    :href="
                                                        route(
                                                            'users.edit',
                                                            user.id
                                                        )
                                                    "
                                                    class="text-blue-600 hover:text-blue-800"
                                                    title="Edit"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </Link>

                                                <button
                                                    @click="
                                                        destroyUser(user.id)
                                                    "
                                                    class="text-red-600 hover:text-red-800"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 flex justify-center space-x-4">
                            <Link
                                v-if="props.users.prev_page_url"
                                :href="props.users.prev_page_url"
                                class="rounded bg-gray-200 px-3 py-1 hover:bg-gray-300"
                            >
                                Sebelumnya
                            </Link>
                            <span class="px-3 py-1">{{
                                props.users.current_page
                            }}</span>
                            <Link
                                v-if="props.users.next_page_url"
                                :href="props.users.next_page_url"
                                class="rounded bg-gray-200 px-3 py-1 hover:bg-gray-300"
                            >
                                Berikutnya
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    users: Object,
});

function destroyUser(id) {
    if (confirm("Yakin ingin menghapus user ini?")) {
        router.delete(route("users.destroy", id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log("User berhasil dihapus.");
            },
            onError: () => {
                console.error("Gagal menghapus user.");
            },
        });
    }
}
</script>
