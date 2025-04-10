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
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

const newTask = ref('')
const tasks = ref([])
const isDarkMode = ref(false)

// Edição
const editingTaskId = ref(null)
const editedTitle = ref('')

// Adicionar tarefa
const addTask = async () => {
  if (!newTask.value.trim()) return

  try {
    const response = await axios.post('http://localhost:8000/api/tasks', {
      title: newTask.value,
    })
    tasks.value.push(response.data)
    newTask.value = ''
  } catch (error) {
    console.error('Erro ao adicionar tarefa:', error)
  }
}

// Marcar como concluída
const markAsDone = async (task) => {
  try {
    await axios.put(`http://localhost:8000/api/tasks/${task.id}`, {
      completed: true,
    })
    task.completed = true
  } catch (error) {
    console.error('Erro ao marcar como concluída:', error)
  }
}

// Remover tarefa
const removeTask = async (taskToRemove) => {
  try {
    await axios.delete(`http://localhost:8000/api/tasks/${taskToRemove.id}`)
    tasks.value = tasks.value.filter(task => task.id !== taskToRemove.id)
  } catch (error) {
    console.error('Erro ao remover tarefa:', error)
  }
}

// Editar tarefa
const startEdit = (task) => {
  editingTaskId.value = task.id
  editedTitle.value = task.title
}

const saveEdit = async (task) => {
  if (!editedTitle.value.trim()) return

  try {
    await axios.put(`http://localhost:8000/api/tasks/${task.id}`, {
      title: editedTitle.value.trim(),
    })
    task.title = editedTitle.value.trim()
    editingTaskId.value = null
    editedTitle.value = ''
  } catch (error) {
    console.error('Erro ao editar tarefa:', error)
  }
}

// Computed
const activeTasks = computed(() => tasks.value.filter(task => !task.completed))
const completedTasks = computed(() => tasks.value.filter(task => task.completed))

// Tema
const toggleTheme = () => {
  isDarkMode.value = !isDarkMode.value
  updateBodyClass()
  localStorage.setItem('darkMode', isDarkMode.value)
}

const updateBodyClass = () => {
  document.body.classList.toggle('dark-mode', isDarkMode.value)
}

// Inicializar
onMounted(async () => {
  isDarkMode.value = localStorage.getItem('darkMode') === 'true'
  updateBodyClass()

  try {
    const response = await axios.get('http://localhost:8000/api/tasks')
    tasks.value = response.data
  } catch (error) {
    console.error('Erro ao buscar tarefas:', error)
  }
})
</script>
