<template>
    
    <div class="container mt-5">
      <h2 class="text-center mb-4">📝 To-Do List</h2>
  
      <!-- Campo para adicionar tarefa -->
      <div class="input-group mb-3">
        <input
          type="text"
          class="form-control"
          placeholder="Digite uma tarefa..."
          v-model="newTask"
          @keyup.enter="addTask"
        />
        <button class="btn btn-primary" @click="addTask">Adicionar</button>
      </div>
  
      <!-- Lista de tarefas ativas -->
      <div>
        <h4>Tarefas Pendentes</h4>
        <ul class="list-group">
          <li
            v-for="task in activeTasks"
            :key="task.id"
            class="list-group-item d-flex justify-content-between align-items-center"
          >
            {{ task.title }}
            <div>
              <button class="btn btn-success btn-sm me-2" @click="markAsDone(task)">
                ✅
              </button>
              <button class="btn btn-danger btn-sm" @click="removeTask(task)">
                🗑
              </button>
            </div>
          </li>
        </ul>
      </div>
  
      <!-- Lista de tarefas concluídas -->
      <div class="mt-4">
        <h4>Tarefas Concluídas</h4>
        <ul class="list-group">
          <li
            v-for="task in completedTasks"
            :key="task.id"
            class="list-group-item d-flex justify-content-between align-items-center list-group-item-success"
          >
            {{ task.title }}
            <button class="btn btn-danger btn-sm" @click="removeTask(task)">
              🗑
            </button>
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  const newTask = ref('');
  const tasks = ref([]);
  
  const addTask = () => {
    if (!newTask.value.trim()) return;
  
    tasks.value.push({
      id: Date.now(),
      title: newTask.value,
      completed: false,
    });
  
    newTask.value = '';
  };
  
  const markAsDone = (task) => {
    task.completed = true;
  };
  
  const removeTask = (taskToRemove) => {
    tasks.value = tasks.value.filter(task => task.id !== taskToRemove.id);
  };
  
  const activeTasks = computed(() =>
    tasks.value.filter(task => !task.completed)
  );
  
  const completedTasks = computed(() =>
    tasks.value.filter(task => task.completed)
  );
  </script>
  