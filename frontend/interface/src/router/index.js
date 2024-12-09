import { createRouter, createWebHistory } from 'vue-router'
import Signup from '@/components/Signup.vue'
import Login from '@/components/Login.vue'
import Users_management from '../views/admin/users/Users_management.vue';
import Dashboard from '../views/Dashboard.vue';
import Home from '../views/Home.vue';
import EditUser from '../views/admin/users/EditUser.vue';
import Create from '../views/tasks/Create.vue';
import Tasks from '../views/tasks/Tasks.vue';
import TaskAssigned from '../views/tasks/TaskAssigned.vue';
import EditTask from '../views/tasks/EditTask.vue';
import AssignedView from '../views/tasks/AssignedView.vue';
import TaskShow from '../views/tasks/TaskShow.vue';
import Chat from '@/components/chat.vue';
import NotificationDetails from '@/views/tasks/NotificationDetails.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/register',
      name: 'signUp',
      component: Signup
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
    {
      path: '/logout',
      name: 'logout',
      
    },
    {
      path: '/chat',
      name: 'chat',
      component: Chat
    },
    {
      path: '/notifications/:id',
      name: 'notificationDetail',
      component: NotificationDetails,
      props: true, // Allows passing route params as props
  }, 
   
   
    {
      path: '/dashboard',
      component: Dashboard,
      meta: { requiresAuth: true },
      children: [
        { path: 'Users_management', component: Users_management,name:'users_management'},
       
          
        {
          path: '/users/edit/:id?',
          name: 'editUser',
          component:EditUser
        } ,
         
        {
          path: 'tasks',
          name: 'tasks',
          component:Tasks
        },
        {
          path: 'taskAssigned',
          name: 'myTasks',
          component:TaskAssigned
        },
        {
          path: 'create',
          name: 'create',
          component:Create
        },
        {
          path: '/task/edit/:id?',
          name: 'editTask',
          component:EditTask
        },
        {
          path: '/task/delete/:id?',
          name: 'deleteTask',
          
        },
        {
          path: '/task/assign/:id?',
          name: 'assignView',
          component:AssignedView
        },
        
        {
          path: '/task/:id?',
          name: 'show',
          component:TaskShow
        },
       
        
       
       
      ]
    },
   
    
    
    
   
   
  ]
});


export default router
