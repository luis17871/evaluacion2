import { CommonModule } from '@angular/common';
import { Component } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { IAsistente } from 'src/app/Interfaces/iasistentes';
import { AsistentesService } from 'src/app/Services/asistentes.service';
import Swal from 'sweetalert2';

@Component({
  selector: 'app-nuevoasistente',
  standalone: true,
  imports: [ReactiveFormsModule, CommonModule],
  templateUrl: './nuevoasistente.component.html',
})
export class NuevoasistenteComponent {
  frm_Cliente = new FormGroup({
    //asistente_id: new FormControl(),
    nombre: new FormControl('', Validators.required),
    apellido: new FormControl('', Validators.required),
    email: new FormControl('', Validators.required),
    telefono: new FormControl('', [Validators.required, ]),
  });
  asistente_id = 0;
  titulo = 'Nuevo Cliente';
  constructor(
    private asistenteService: AsistentesService,
    private navegacion: Router,
    private ruta: ActivatedRoute,
  ) {}

  ngOnInit(): void {
    this.asistente_id = parseInt(this.ruta.snapshot.paramMap.get('id'));
    if (this.asistente_id > 0) {
      console.log(this.asistente_id);
      this.asistenteService.uno(this.asistente_id).subscribe((uncliente) => {
        console.log(uncliente);
        this.frm_Cliente.controls['nombre'].setValue(uncliente.nombre);
        this.frm_Cliente.controls['apellido'].setValue(uncliente.apellido);
        this.frm_Cliente.controls['email'].setValue(uncliente.email);
        this.frm_Cliente.controls['telefono'].setValue(uncliente.telefono);


        this.titulo = 'Editar Cliente';
      });
    }
  }

  grabar() {
    let asistente: IAsistente = {
      asistente_id: this.asistente_id,
      nombre: this.frm_Cliente.controls['nombre'].value,
      apellido: this.frm_Cliente.controls['apellido'].value,
      email: this.frm_Cliente.controls['email'].value,
      telefono: this.frm_Cliente.controls['telefono'].value,
    };

    Swal.fire({
      title: 'Clientes',
      text: 'Desea gurdar al Cliente ' + this.frm_Cliente.controls['nombre'].value,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#f00',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Grabar!'
    }).then((result) => {
      if (result.isConfirmed) {
        if (this.asistente_id > 0) {
          this.asistenteService.actualizar(asistente).subscribe((res: any) => {
            Swal.fire({
              title: 'asistentes',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/asistentes']);
          });
        } else {
          this.asistenteService.insertar(asistente).subscribe((res: any) => {
            Swal.fire({
              title: 'asistentes',
              text: res.mensaje,
              icon: 'success'
            });
            this.navegacion.navigate(['/asistentes']);
          });
        }
      }
    });
  }


}
