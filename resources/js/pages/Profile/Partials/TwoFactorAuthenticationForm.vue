<script setup lang="ts">
import {ref, computed, watch} from 'vue';
import {router, useForm, usePage} from '@inertiajs/vue3';
import {
  Card,
  CardContent, CardFooter,
} from '@/components/ui/card'
import {Input} from "@/components/ui/input";
import {Label} from "@/components/ui/label";
import {Button} from "@/components/ui/button";
import ConfirmsPassword from "@/components/ConfirmsPassword.vue";
import {CardHeader, CardTitle} from "@/components/ui/card";

const props = defineProps({
  requiresConfirmation: Boolean,
});

const page = usePage();
const enabling = ref(false);
const confirming = ref(false);
const disabling = ref(false);
const qrCode = ref(null);
const setupKey = ref(null);
const recoveryCodes = ref([]);

const confirmationForm = useForm({
  code: '',
});

const twoFactorEnabled = computed(
  () => !enabling.value && page.props.auth.user?.two_factor_enabled,
);

watch(twoFactorEnabled, () => {
  if (!twoFactorEnabled.value) {
    confirmationForm.reset();
    confirmationForm.clearErrors();
  }
});

const enableTwoFactorAuthentication = () => {
  enabling.value = true;

  router.post(route('two-factor.enable'), {}, {
    preserveScroll: true,
    onSuccess: () => Promise.all([
      showQrCode(),
      showSetupKey(),
      showRecoveryCodes(),
    ]),
    onFinish: () => {
      enabling.value = false;
      confirming.value = props.requiresConfirmation;
    },
  });
};

const showQrCode = () => {
  return axios.get(route('two-factor.qr-code')).then(response => {
    qrCode.value = response.data.svg;
  });
};

const showSetupKey = () => {
  return axios.get(route('two-factor.secret-key')).then(response => {
    setupKey.value = response.data.secretKey;
  });
}

const showRecoveryCodes = () => {
  return axios.get(route('two-factor.recovery-codes')).then(response => {
    recoveryCodes.value = response.data;
  });
};

const confirmTwoFactorAuthentication = () => {
  confirmationForm.post(route('two-factor.confirm'), {
    errorBag: "confirmTwoFactorAuthentication",
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      confirming.value = false;
      qrCode.value = null;
      setupKey.value = null;
    },
  });
};

const regenerateRecoveryCodes = () => {
  axios
    .post(route('two-factor.recovery-codes'))
    .then(() => showRecoveryCodes());
};

const disableTwoFactorAuthentication = () => {
  disabling.value = true;

  router.delete(route('two-factor.disable'), {
    preserveScroll: true,
    onSuccess: () => {
      disabling.value = false;
      confirming.value = false;
    },
  });
};
</script>

<template>
  <Card id="mfa">
    <CardHeader>
      <CardTitle>Two Factor Authentication</CardTitle>
    </CardHeader>
    <CardContent>
      <h3 v-if="twoFactorEnabled && ! confirming" class="text-lg font-medium">
        You have enabled two factor authentication.
      </h3>
      <h3 v-else-if="twoFactorEnabled && confirming" class="text-lg font-medium">
        Finish enabling two factor authentication.
      </h3>
      <h3 v-else class="text-lg font-medium">
        You have not enabled two factor authentication.
      </h3>
      <div class="mt-3 max-w-xl text-sm">
        <p>
          When two factor authentication is enabled, you will be prompted for a secure, random token during
          authentication. You may retrieve this token from your phone's Google Authenticator application.
        </p>
      </div>
      <div v-if="twoFactorEnabled">
        <div v-if="qrCode">
          <div class="mt-4 max-w-xl text-sm">
            <p v-if="confirming" class="font-semibold">
              To finish enabling two factor authentication, scan the following QR code using your phone's authenticator
              application or enter the setup key and provide the generated OTP code.
            </p>
            <p v-else>
              Two factor authentication is now enabled. Scan the following QR code using your phone's authenticator
              application or enter the setup key.
            </p>
          </div>
          <div class="mt-4 p-2 inline-block bg-white" v-html="qrCode"/>
          <div v-if="setupKey" class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
            <p class="font-semibold">
              Setup Key: <span v-html="setupKey"></span>
            </p>
          </div>
          <div v-if="confirming" class="mt-6">
            <Label for="code" class="block text-sm font-medium leading-6">
              MFA Code
            </Label>
            <div class="mt-2">
              <Input
                id="code"
                name="code"
                type="text"
                autocomplete="off"
                placeholder="MFA Code"
                required
                v-model="confirmationForm.code"
                @keyup.enter="confirmTwoFactorAuthentication"
                class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-ring placeholder:text-foreground focus:ring-2 focus:ring-inset focus:ring-ring sm:text-sm sm:leading-6"
              />
              <template v-if="confirmationForm.code">
                <p class="mt-2 text-md text-destructive">
                  {{ confirmationForm.code }}
                </p>
              </template>
            </div>
          </div>
        </div>
        <div v-if="recoveryCodes.length > 0 && ! confirming">
          <div class="mt-4 max-w-xl text-sm">
            <p class="font-semibold">
              Store these recovery codes in a secure password manager. They can be used to recover access to your
              account if your two factor authentication device is lost.
            </p>
          </div>
          <div
            class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 dark:bg-gray-900 dark:text-gray-100 rounded-lg">
            <div v-for="code in recoveryCodes" :key="code">
              {{ code }}
            </div>
          </div>
        </div>
      </div>
    </CardContent>
    <CardFooter class="border-t px-6 py-4">
      <div v-if="! twoFactorEnabled">
        <ConfirmsPassword @confirmed="enableTwoFactorAuthentication">
          <Button :class="{ 'opacity-25': enabling }" :disabled="enabling">
            Enable
          </Button>
        </ConfirmsPassword>
      </div>
      <div v-else>
        <ConfirmsPassword @confirmed="confirmTwoFactorAuthentication">
          <Button
            v-if="confirming"
            type="button"
            class="me-3"
            :class="{ 'opacity-25': enabling }"
            :disabled="enabling"
          >
            Confirm
          </Button>
        </ConfirmsPassword>
        <ConfirmsPassword @confirmed="regenerateRecoveryCodes">
          <Button
            v-if="recoveryCodes.length > 0 && ! confirming"
            class="me-3"
          >
            Regenerate Recovery Codes
          </Button>
        </ConfirmsPassword>
        <ConfirmsPassword @confirmed="showRecoveryCodes">
          <Button
            v-if="recoveryCodes.length === 0 && ! confirming"
            class="me-3"
          >
            Show Recovery Codes
          </Button>
        </ConfirmsPassword>
        <ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
          <Button
            v-if="confirming"
            :class="{ 'opacity-25': disabling }"
            :disabled="disabling"
          >
            Cancel
          </Button>
        </ConfirmsPassword>
        <ConfirmsPassword @confirmed="disableTwoFactorAuthentication">
          <Button
            v-if="! confirming"
            :class="{ 'opacity-25': disabling }"
            :disabled="disabling"
          >
            Disable
          </Button>
        </ConfirmsPassword>
      </div>
    </CardFooter>
  </Card>
</template>
