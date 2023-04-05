import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { RouterModule, Routes } from '@angular/router';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import {MaterialModule} from './material-module'

import { RegistroComponent } from './registro/registro.component';
import { InformesComponent } from './informes/informes.component';
import { ConductorFormComponent } from './conductor-form/conductor-form.component';
import { VehiculoFormComponent } from './vehiculo-form/vehiculo-form.component';

const appRoutes: Routes = [
  { path: 'registro', component: RegistroComponent },
  { path: 'informes', component: InformesComponent },
];


@NgModule({
  declarations: [
    AppComponent,
    RegistroComponent,
    ConductorFormComponent,
    VehiculoFormComponent
  ],
  imports: [
    RouterModule.forRoot(appRoutes),
    MaterialModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
