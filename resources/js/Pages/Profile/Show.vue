<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import DeleteUserForm from '@/Pages/Profile/Partials/DeleteUserForm.vue'
import LogoutOtherBrowserSessionsForm from '@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue'
import TwoFactorAuthenticationForm from '@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue'
import UpdatePasswordForm from '@/Pages/Profile/Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from '@/Pages/Profile/Partials/UpdateProfileInformationForm.vue'
import { Separator } from '@/Components/shadcn/ui/separator/index.js'

defineProps({
	confirmsTwoFactorAuthentication: Boolean,
	sessions: Array,
})
</script>

<template>
	<AppLayout title="Profile">
		<div class="container flex flex-col gap-6">
			<UpdateProfileInformationForm
				v-if="$page.props.jetstream.canUpdateProfileInformation"
				:user="$page.props.auth.user" />

			<Separator />

			<UpdatePasswordForm v-if="$page.props.jetstream.canUpdatePassword" />

			<Separator />

			<TwoFactorAuthenticationForm
				v-if="$page.props.jetstream.canManageTwoFactorAuthentication"
				:requires-confirmation="confirmsTwoFactorAuthentication" />

			<Separator />

			<LogoutOtherBrowserSessionsForm :sessions="sessions" />

			<Separator />

			<DeleteUserForm v-if="$page.props.jetstream.hasAccountDeletionFeatures" />
		</div>
	</AppLayout>
</template>
