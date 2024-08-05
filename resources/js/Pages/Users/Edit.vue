<script setup>
import AppLayout from "@/Layouts/AppLayout.vue"
import UserForm from "./Partials/UserForm.vue"

defineProps({
	user: Object
})
</script>

<template>
	<AppLayout title="Edit user">
		<UserForm :user="user" />
	</AppLayout>
</template>
