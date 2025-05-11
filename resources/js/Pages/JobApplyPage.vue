<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const { job } = usePage().props;

const form = useForm({
  cover_letter: '',
  resume: null,
});

const submitApplication = () => {
  form.post(route('jobs.apply', job.id), {
    forceFormData: true
  });
};
</script>

<template>
  <AppLayout>
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-2xl font-bold mb-4">Apply for {{ job.title }}</h1>

      <form @submit.prevent="submitApplication">
        <div class="mb-4">
          <label class="block text-gray-700">Cover Letter</label>
          <textarea v-model="form.cover_letter" class="w-full border rounded p-2 mt-1"></textarea>
        </div>

        <div class="mb-4">
          <label class="block text-gray-700">Resume</label>
          <input type="file" @change="e => form.resume = e.target.files[0]" class="mt-1" />
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Submit Application
        </button>
        <p v-if="$page.props.success" class="text-green-600">
  {{ $page.props.success }}
</p>

      </form>
    </div>
  </AppLayout>
</template>
