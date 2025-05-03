<template>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
      <!-- Page Title -->
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Post a New Job</h2>
  
      <!-- Job Posting Form -->
      <form @submit.prevent="submitJob" class="space-y-6">
        <div class="form-group">
          <label for="title" class="block text-gray-700">Job Title</label>
          <input
            v-model="form.title"
            type="text"
            id="title"
            name="title"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            placeholder="Enter the job title"
            :class="{'border-red-500': errors.title}"
          />
          <span v-if="errors.title" class="text-red-500 text-sm">{{ errors.title }}</span>
        </div>
  
        <div class="form-group">
          <label for="description" class="block text-gray-700">Job Description</label>
          <textarea
            v-model="form.description"
            id="description"
            name="description"
            rows="4"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            placeholder="Describe the job responsibilities"
            :class="{'border-red-500': errors.description}"
          ></textarea>
          <span v-if="errors.description" class="text-red-500 text-sm">{{ errors.description }}</span>
        </div>
  
        <div class="form-group">
          <label for="location" class="block text-gray-700">Location</label>
          <input
            v-model="form.location"
            type="text"
            id="location"
            name="location"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600"
            placeholder="Enter the job location"
            :class="{'border-red-500': errors.location}"
          />
          <span v-if="errors.location" class="text-red-500 text-sm">{{ errors.location }}</span>
        </div>
  
        <div class="flex justify-end">
          <button
            type="submit"
            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600 transition duration-200"
          >
            Post Job
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import { router } from '@inertiajs/vue3';
  import { Inertia } from '@inertiajs/inertia'; 
  import AppLayout from '@/Layouts/AppLayout.vue';
  
  const form = ref({
    title: '',
    description: '',
    location: '',
  });
  
  const errors = ref({
    title: null,
    description: null,
    location: null,
  });
  
  const submitJob = () => {
    errors.value = {}; // Clear previous errors
  
    Inertia.post('/post-job', form.value, {
      onError: (error) => {
        // Handle validation errors
        if (error.response && error.response.data.errors) {
          errors.value = error.response.data.errors;
        }
      },
      onSuccess: () => {
        // Redirect or show success message after successful job post
        Inertia.visit('/jobs'); // Redirect to Job Listings
      },
    });
  };
  </script>
  
  <style scoped>
  /* Optional: Custom styling for the form */
  .form-group {
    margin-bottom: 1.5rem;
  }
  </style>
  