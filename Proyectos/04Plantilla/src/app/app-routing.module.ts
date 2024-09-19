// angular import
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

// Project import
import { AdminComponent } from './theme/layouts/admin-layout/admin-layout.component';
import { GuestComponent } from './theme/layouts/guest/guest.component';
import { usuariosGuardGuard } from './Guards/usuarios-guard.guard';

const routes: Routes = [
  {
    path: '', //url
    component: AdminComponent,
    children: [
      {
        path: '',
        redirectTo: '/dashboard/default',
        pathMatch: 'full'
      },
      {
        path: 'dashboard/default',
        loadComponent: () => import('./demo/default/dashboard/dashboard.component').then((c) => c.DefaultComponent),
        
      },
      {
        path: 'typography',
        loadComponent: () => import('./demo/ui-component/typography/typography.component')
      },
      {
        path: 'color',
        loadComponent: () => import('./demo/ui-component/ui-color/ui-color.component')
      },
      {
        path: 'sample-page',
        loadComponent: () => import('./demo/other/sample-page/sample-page.component')
      },
      {
        path: 'asistentes',
        loadComponent: () => import('./asistentes/asistentes.component').then((m) => m.AsistentesComponent),
        
      },
      {
        path: 'nuevoasistente',
        loadComponent: () => import('./asistentes/nuevoasistente/nuevoasistente.component').then((m) => m.NuevoasistenteComponent),
        
      },
      {
        path: 'editarasistente/:id',
        loadComponent: () => import('./asistentes/nuevoasistente/nuevoasistente.component').then((m) => m.NuevoasistenteComponent),
        
      },
      {
        path: 'conferencias',
        loadComponent: () => import('./conferencias/conferencias.component').then((m) => m.ConferenciasComponent),
        
      },
      {
        path: 'nuevaconferencia',
        loadComponent: () => import('./conferencias/nuevaconferencia/nuevaconferencia.component').then((m) => m.NuevaconferenciaComponent),
        
      },
      {
        path: 'editarconferencia/:id',
        loadComponent: () => import('./conferencias/nuevaconferencia/nuevaconferencia.component').then((m) => m.NuevaconferenciaComponent),
        
      },
      {
        path: 'editarregistroconferencia/:id',
        loadComponent: () => import('./registroconferencia/nuevoregistroconferencia/nuevoregistroconferencia.component').then((m) => m.NuevoregistroconferenciaComponent)
      },
      {
        path: 'nuevaregistroconferencia',
        loadComponent: () => import('./registroconferencia/nuevoregistroconferencia/nuevoregistroconferencia.component').then((m) => m.NuevoregistroconferenciaComponent),
        
      },
      {
        path: 'registroconferencias',
        loadComponent: () => import('./registroconferencia/registroconferencia.component').then((m) => m.RegistroconferenciaComponent)
      },
     
    ]
  },
  {
    path: '',
    component: GuestComponent,
    children: [
      {
        path: 'login',
        loadComponent: () => import('./demo/authentication/login/login.component')
      },
      {
        path: 'login/:id',
        loadComponent: () => import('./demo/authentication/login/login.component')
      },
      {
        path: 'register',
        loadComponent: () => import('./demo/authentication/register/register.component')
      }
    ]
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {}
