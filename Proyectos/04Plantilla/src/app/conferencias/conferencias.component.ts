import { Component } from '@angular/core';
import { IConferencia } from '../Interfaces/iconferencia';
import { ConfererenciaService } from '../Services/conferencias.service';
import Swal from 'sweetalert2';
import { SharedModule } from '../theme/shared/shared.module';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-conferencias',
  standalone: true,
  imports: [RouterLink, SharedModule],
  templateUrl: './conferencias.component.html',
})
export class ConferenciasComponent {
  listaAsistentes: IConferencia[] = [];
  constructor(private conferenciaService: ConfererenciaService) {}

  ngOnInit() {
    this.cargatabla();
  }
  cargatabla() {
    this.conferenciaService.todos().subscribe((data) => {
      console.log(data);
      this.listaAsistentes = data;
    });
  }
  abrirInforme() {
    window.open('http://localhost/Sexto/Sexto/Proyectos/03MVC/reports/conferencias.report.php');
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
        this.conferenciaService.eliminar(idClientes).subscribe((data) => {
          Swal.fire('Eliminado!', '', 'success');
          this.cargatabla();
        });
      }
    });
  }
}
