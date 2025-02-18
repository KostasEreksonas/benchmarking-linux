import { Component } from '@angular/core';
import {Router, RouterLink} from '@angular/router';
import {CommonModule} from '@angular/common';
import {FormsModule, NgForm} from '@angular/forms';
import {AuthService} from '../../services/auth.service';

@Component({
  selector: 'app-registration-form',
  imports: [RouterLink, CommonModule, FormsModule],
  templateUrl: './registration-form.component.html',
  styleUrl: './registration-form.component.css'
})
export class RegistrationFormComponent {
  public email:string | null = null;
  public email_repeat:string | null = null;
  public username:string | null = null;
  public password:string | null = null;
  public password_repeat:string | null = null;
  public message:string = "";
  public status:number = 0;
  public isError:boolean = false;

  public constructor(private auth:AuthService, private router:Router) {
  }

  public register(f:NgForm) {
      this.auth.register("register", f.form.value.username, f.form.value.email, f.form.value.password).subscribe({
        next:()=>{
          this.router.navigate(['login']);
        },
        error:(error)=>{
          this.isError = true;
          if (error.error === null) {
            this.status = error.status;
            this.message = error.message;
          } else {
            this.status = error.error.status;
            this.message = error.error.message;
          }
        }
      });
    }
}
