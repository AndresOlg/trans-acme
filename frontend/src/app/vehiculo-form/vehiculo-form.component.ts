import { Component, EventEmitter, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-vehiculo-form',
  templateUrl: './vehiculo-form.component.html',
  styleUrls: ['./vehiculo-form.component.css']
})
export class VehiculoFormComponent {
  @Output() vehiculoFormSubmitted = new EventEmitter<FormGroup>();

  vehiculoForm: FormGroup;

  constructor(private fb: FormBuilder) {
    this.vehiculoForm = this.fb.group({
      placa: ['', Validators.required],
      motor: [''],
      marca: ['', Validators.required],
      color: [''],
      tipo_vehiculo: ['', Validators.required]
    });
  }

  submit() {
    if (this.vehiculoForm.valid) {
      this.vehiculoFormSubmitted.emit(this.vehiculoForm.value);
    }
  }
}
