import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ConductorService } from '../services/conductor.service';
import { VehiculoService } from '../services/vehiculo.service';

@Component({
  selector: 'app-registro',
  templateUrl: './registro.component.html',
  styleUrls: ['./registro.component.css']
})
export class RegistroComponent {
  conductorForm: FormGroup;
  vehiculoForm: FormGroup;

  constructor(
    private fb: FormBuilder,
    private conductorService: ConductorService,
    private vehiculoService: VehiculoService
  ) {
    this.conductorForm = this.fb.group({
      es_propietario: false,
      nro_cedula: ['', Validators.required],
      primer_nombre: ['', Validators.required],
      segundo_nombre: [''],
      apellidos: ['', Validators.required],
      telefono: ['', Validators.required],
      direccion: ['', Validators.required],
      ciudad: ['', Validators.required]
    });

    this.vehiculoForm = this.fb.group({
      placa: ['', Validators.required],
      motor: [''],
      marca: ['', Validators.required],
      color: [''],
      tipo_vehiculo: ['', Validators.required],
      id_conductor: [null, Validators.required]
    });
  }

  guardar(): void {
    const conductor = this.conductorForm.value;
    const vehiculo = this.vehiculoForm.value;

    this.conductorService.create(conductor).subscribe(c => {
      vehiculo.id_conductor = c.id;
      this.vehiculoService.create(vehiculo).subscribe();
    });
  }
}
