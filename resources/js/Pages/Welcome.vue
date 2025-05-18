<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="JanjiDokterku - Booking Mudah & Cepat" />

    <div class="min-h-screen bg-white text-gray-800 flex flex-col">
        <header
            class="flex justify-between items-center px-6 py-5 border-b border-gray-200"
        >
            <div class="text-2xl font-bold text-red-600">JanjiDokterku</div>
            <nav class="space-x-4">
                <Link
                    v-if="$page.props.auth.user"
                    href="/dashboard"
                    class="text-gray-700 hover:text-red-600 font-semibold"
                    >Dashboard</Link
                >
                <template v-else>
                    <Link
                        href="/login"
                        class="text-gray-700 hover:text-red-600 font-semibold"
                        >Login</Link
                    >
                    <Link
                        v-if="canRegister"
                        href="/register"
                        class="text-gray-700 hover:text-red-600 font-semibold"
                        >Register</Link
                    >
                </template>
            </nav>
        </header>

        <main
            class="flex-grow flex flex-col-reverse lg:flex-row items-center max-w-7xl mx-auto px-6 py-16 gap-12"
        >
            <!-- Teks utama -->
            <section class="max-w-xl text-center lg:text-left">
                <h1 class="text-4xl font-extrabold text-red-600 mb-4">
                    Booking Janji dengan Dokter <br />
                    Mudah & Cepat
                </h1>
                <p class="mb-8 text-gray-600">
                    Kelola jadwal konsultasi Anda tanpa ribet. Temukan dokter
                    terbaik dan buat janji kapan saja, di mana saja.
                </p>
                <div class="space-x-4">
                    <Link
                        href="/register"
                        class="inline-block bg-red-600 text-white px-6 py-3 rounded-md font-semibold shadow hover:bg-red-700 transition"
                        >Daftar Sekarang</Link
                    >
                    <Link
                        href="/login"
                        class="inline-block border border-red-600 text-red-600 px-6 py-3 rounded-md font-semibold hover:bg-red-100 transition"
                        >Masuk</Link
                    >
                </div>
            </section>

            <!-- Ilustrasi -->
            <section class="max-w-md">
                <img
                    src="/img/headerLanding.jpg"
                    alt="Ilustrasi janji dokter"
                    class="w-full h-auto"
                    loading="lazy"
                />
            </section>
        </main>

        <footer
            class="border-t border-gray-200 text-center text-gray-500 py-6 text-sm"
        >
            &copy; 2025 JanjiDokterku. All rights reserved.
        </footer>
    </div>
</template>
