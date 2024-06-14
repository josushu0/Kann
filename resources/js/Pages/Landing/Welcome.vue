<script setup>
import { Head } from '@inertiajs/vue3'
import Navbar from '@/Pages/Landing/Partials/Navbar.vue'

defineProps({
	canLogin: Boolean,
	canRegister: Boolean,
})
</script>

<template>
	<div class="bg-background">
		<Head title="Welcome" />
		<Navbar :canLogin="canLogin" :canRegister="canRegister" />
	</div>
</template>
