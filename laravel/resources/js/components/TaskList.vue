<template>
    <div>
      <h1>Minhas Tarefas</h1>
      <ul>
        <li v-for="task in tasks" :key="task.id">
          {{ task.title }} - {{ task.completed ? '✅' : '❌' }}
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { onMounted, ref } from 'vue';
  import axios from 'axios';
  
  const tasks = ref([]);
  
  onMounted(async () => {
    const response = await axios.get('/api/tasks');
    tasks.value = response.data;
  });
  </script>
  