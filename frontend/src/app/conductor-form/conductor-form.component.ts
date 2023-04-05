import { Component, EventEmitter, Output } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-conductor-form',
  templateUrl: './conductor-form.component.html',
  styleUrls: ['./conductor-form.component.css']
})
export class ConductorFormComponent {
  @Output() formSubmitted = new EventEmitter<FormGroup>();
  conductorForm: FormGroup;

  constructor(private fb: FormBuilder) {
    this.conductorForm = this.fb.group({
      es_propietario: [false],
      nro_cedula: ['', [Validators.required, Validators.maxLength(20)]],
      primer_nombre: ['', Validators.required],
      segundo_nombre: [''],
      apellidos: ['', Validators.required],
      telefono: ['', Validators.required],
      direccion: ['', Validators.required],
      ciudad: ['', Validators.required],
    });
  }

  onSubmit() {
    if (this.conductorForm.valid) {
      this.formSubmitted.emit(this.conductorForm);
    }
  }
}
