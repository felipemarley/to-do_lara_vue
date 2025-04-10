<template>
    <div class="container mt-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-center">📝 To-Do List</h2>
        <button class="btn btn-secondary" @click="toggleTheme">
          {{ isDarkMode ? '☀️' : '🌙' }}
        </button>
      </div>
  
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
            <div class="flex-grow-1 me-2">
              <template v-if="editingTaskId === task.id">
                <input
                  type="text"
                  class="form-control"
                  v-model="editedTitle"
                  @keyup.enter="saveEdit(task)"
                  @blur="saveEdit(task)"
                  autofocus
                />
              </template>
              <template v-else>
                {{ task.title }}
              </template>
            </div>
            <div>
              <button
                v-if="editingTaskId !== task.id"
                class="btn btn-warning btn-sm me-2"
                @click="startEdit(task)"
              >
                ✏️
              </button>
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
  import { ref, computed, onMounted } from 'vue';
  
  const newTask = ref('');
  const tasks = ref([]);
  const isDarkMode = ref(false);
  
  // Edição
  const editingTaskId = ref(null);
  const editedTitle = ref('');
  
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
  
  const startEdit = (task) => {
    editingTaskId.value = task.id;
    editedTitle.value = task.title;
  };
  
  const saveEdit = (task) => {
    if (editedTitle.value.trim()) {
      task.title = editedTitle.value.trim();
    }
    editingTaskId.value = null;
    editedTitle.value = '';
  };
  
  const activeTasks = computed(() =>
    tasks.value.filter(task => !task.completed)
  );
  
  const completedTasks = computed(() =>
    tasks.value.filter(task => task.completed)
  );
  
  const toggleTheme = () => {
    isDarkMode.value = !isDarkMode.value;
    updateBodyClass();
    localStorage.setItem('darkMode', isDarkMode.value);
  };
  
  const updateBodyClass = () => {
    if (isDarkMode.value) {
      document.body.classList.add('dark-mode');
    } else {
      document.body.classList.remove('dark-mode');
    }
  };
  
  onMounted(() => {
    isDarkMode.value = localStorage.getItem('darkMode') === 'true';
    updateBodyClass();
  });
  </script>
  