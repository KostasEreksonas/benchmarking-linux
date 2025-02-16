import { Component } from '@angular/core';
import {CommonModule} from '@angular/common';
import {Router, RouterLink} from '@angular/router';
import {FormsModule, NgForm} from '@angular/forms';
import {AuthService} from '../../services/auth.service';

@Component({
  selector: 'app-login-form',
  imports: [CommonModule, RouterLink, FormsModule],
  templateUrl: './login-form.component.html',
  styleUrl: './login-form.component.css'
})
export class LoginFormComponent {
  public email:string|null=null;
  public password:string|null=null;
  public status:number|null = null;
  public message:string = "";
  public isError:boolean = false;

  public constructor(private auth:AuthService, private router:Router){

  }

  public login(f:NgForm) {
    this.auth.login("login", null, f.form.value.email, f.form.value.password).subscribe({
      next:(data)=>{
        this.auth.authorize(data.token).subscribe({
          next:(data)=>{
            localStorage.setItem('email', data.data.email);
            localStorage.setItem('name', data.data.name);
            localStorage.setItem('date', data.data.date);
            this.router.navigate(['profile', data.data.name]).then(()=>{
              window.location.reload();
            });
          }
        });
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
