import { Routes } from '@angular/router';
import {AboutComponent} from './components/about/about.component';
import {BenchInfoComponent} from './components/bench-info/bench-info.component';
import {LoginFormComponent} from './components/login-form/login-form.component';
import {RegistrationFormComponent} from './components/registration-form/registration-form.component';
import {UploadResultComponent} from './components/upload-result/upload-result.component';
import {EditResultComponent} from './components/edit-result/edit-result.component';
import {ProfileComponent} from './components/profile/profile.component';
import {ResultsComponent} from './components/results/results.component';

export const routes: Routes = [
  {path:"", component:AboutComponent},
  {path:"about", component:AboutComponent},
  {path:"benchmarks", component:BenchInfoComponent},
  {path:"login", component:LoginFormComponent},
  {path:"register", component:RegistrationFormComponent},
  {path:"upload", component:UploadResultComponent},
  {path:"profile/:username", component:ProfileComponent},
  {path:"benchmarks/:benchmark", component:ResultsComponent},
  {path:"benchmarks/:benchmark/:id", component:EditResultComponent}
];
