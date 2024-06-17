<script setup>
import { useForm } from '@inertiajs/vue3'
import {
	Card,
	CardContent,
	CardDescription,
} from '@/Components/shadcn/ui/card/index.js'
import { Icon } from '@iconify/vue'
import ConfirmsPassword from '@/Components/ConfirmsPassword.vue'
import { Button } from '@/Components/shadcn/ui/button/index.js'

defineProps({
	sessions: Array,
})

const form = useForm({
	password: '',
})

const logoutOtherBrowserSessions = (password) => {
	form.password = password
	form.delete(route('other-browser-sessions.destroy'), {
		preserveScroll: true,
		preserveState: true,
		onFinish: () => form.reset(),
	})
}
</script>

<template>
	<div class="grid gap-4 md:grid-cols-3">
		<div>
			<h2 class="font-bold">Browser Sessions</h2>
			<p class="text-sm">
				Manage and log out your active sessions on other browsers and devices.
			</p>
		</div>

		<Card class="col-span-2">
			<CardContent class="mt-6 space-y-4">
				<CardDescription>
					If necessary, you may log out of all of your other browser sessions
					across all of your devices. Some of your recent sessions are listed
					below; however, this list may not be exhaustive. If you feel your
					account has been compromised, you should also update your password.
				</CardDescription>

				<!-- Other Browser Sessions -->
				<div v-if="sessions.length > 0" class="space-y-2">
					<div
						v-for="(session, key) in sessions"
						:key="key"
						class="flex items-center gap-4">
						<Icon
							v-if="session.agent.is_desktop"
							icon="lucide:monitor"
							class="size-8" />
						<Icon v-else icon="lucide:smartphone" class="size-8" />
						<div>
							<div class="text-sm">
								{{
									session.agent.platform ? session.agent.platform : 'Unknown'
								}}
								-
								{{ session.agent.browser ? session.agent.browser : 'Unknown' }}
							</div>
							<div class="text-xs">
								{{ session.ip_address }},

								<span v-if="session.is_current_device" class="font-semibold">
									This device
								</span>
								<span v-else>Last active {{ session.last_active }}</span>
							</div>
						</div>
					</div>
				</div>

				<!-- Actions -->
				<div class="flex items-center justify-end gap-2">
					<transition
						leave-active-class="transition ease-in duration-1000"
						leave-from-class="opacity-100"
						leave-to-class="opacity-0">
						<span
							v-show="form.recentlySuccessful"
							class="text-sm text-gray-600">
							Done.
						</span>
					</transition>
					<ConfirmsPassword
						title="Log Out Other Browser Sessions"
						content="Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices."
						button="Log Out Other Browser Sessions"
						:alwaysAsk="true"
						@confirmed="(password) => logoutOtherBrowserSessions(password)">
						<Button> Log Out Other Browser Sessions</Button>
					</ConfirmsPassword>
				</div>
			</CardContent>
		</Card>
	</div>
</template>
