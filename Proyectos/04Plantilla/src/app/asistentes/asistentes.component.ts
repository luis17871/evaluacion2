import { Component } from '@angular/core';
import { IAsistente } from '../Interfaces/iasistentes';
import { AsistentesService } from '../Services/asistentes.service';
import Swal from 'sweetalert2';
import { RouterLink } from '@angular/router';
import { SharedModule } from '../theme/shared/shared.module';

@Component({
  selector: 'app-asistentes',
  standalone: true,
  imports: [RouterLink, SharedModule],
  templateUrl: './asistentes.component.html',
  styleUrl: './asistentes.component.scss'
})
export class AsistentesComponent {
  listaAsistentes: IAsistente[] = [];
  constructor(private asistentesService: AsistentesService) {}

  ngOnInit() {
    this.cargatabla();
  }
  cargatabla() {
    this.asistentesService.todos().subscribe((data) => {
      console.log(data);
      this.listaAsistentes = data;
    });
  }
  eliminar(idClientes) {
    Swal.fire({
      title: 'Clientes',
      text: 'Esta seguro que desea eliminar el cliente!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Eliminar'
    }).then((result) => {
      if (result.isConfirmed) {
        this.asistentesService.eliminar(idClientes).subscribe((data) => {
          Swal.fire('Eliminado!', '', 'success');
          this.cargatabla();
        });
      }
    });
  }
}
