<template>
  <auth-header label="Sign In"></auth-header>

  <ParentTransition appear :visibility="true">
    <div class="space-y-6">
      <BaseInput type="text" name="email" label="Email" autofocus />

      <BaseInput type="password" name="password" label="Password" />

      <div class="flex items-center justify-between">
        <BaseLink to="Password">Forgot Password?</BaseLink>
      </div>

      <BaseButton @click="router.push({ name: 'Dashboard' })" block
        >Login</BaseButton
      >
      <div class="flex items-center justify-center">
        <BaseLink to="Register">Don't have any account? Register Here</BaseLink>
      </div>
    </div>
  </ParentTransition>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();
</script>