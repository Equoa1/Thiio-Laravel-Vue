<template>
    <div class="icon-container">
      <v-btn icon class="icon-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-svg">
          <title>account</title>
          <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
        </svg>
      </v-btn>
      <span class="icon-text">Account</span>
    </div>
  </template>
  
  <script setup>
  </script>
  
  <style scoped>
  .icon-container {
    display: flex;
    align-items: center;
  }
  
  .icon-btn {
    min-width: auto; 
  }
  
  .icon-svg {
    width: 24px;
    height: 24px;
    fill: currentColor; 
    margin-right: 8px; 
  }
  
  .icon-text {
    font-size: 16px; 
  }
  </style>
  