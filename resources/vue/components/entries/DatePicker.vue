<template>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const date = ref();

onMounted(() => {
  const startDate = new Date();
  const endDate = new Date(new Date().setDate(startDate.getDate() + 7));
  date.value = [startDate, endDate];
})
</script>
