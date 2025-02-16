import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import {AboutComponent} from './components/about/about.component';
import {BenchInfoComponent} from './components/bench-info/bench-info.component';
import {NavigationComponent} from './components/navigation/navigation.component';
import {LoginFormComponent} from './components/login-form/login-form.component';
import {RegistrationFormComponent} from './components/registration-form/registration-form.component';
import {UploadResultComponent} from './components/upload-result/upload-result.component';

@Component({
  selector: 'app-root',
  imports: [
    RouterOutlet,
    AboutComponent,
    BenchInfoComponent,
    NavigationComponent,
    LoginFormComponent,
    RegistrationFormComponent,
    UploadResultComponent
  ],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'Linux-greitaveikos-testavimas';
}
