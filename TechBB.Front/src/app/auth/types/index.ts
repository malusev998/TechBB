import { User } from 'src/app/shared/models/user.model';

export interface AuthStateType {
  errors: { [ key: string ]: Array<string> } | null;
  user: User | null;
}

/*
 {token: "eyJhbGciOiJSUzUxMiJ9.eyJuYW1lIjoiRHVzYW4iLCJzdXJuY…2rRU-WLcKiK0-5gz8E8atd6Y_4B5WOtZJjyjxnru0haD5keLA", expires: 120, type: "Bearer", payload: {…}}
 token: "eyJhbGciOiJSUzUxMiJ9.eyJuYW1lIjoiRHVzYW4iLCJzdXJuYW1lIjoiTWFsdXNldiIsImVtYWlsIjoibWFsdXNldmQ5OUBnbWFpbC5jb20iLCJyb2xlIjoiYWRtaW4iLCJpYXQiOjE1ODE5NTEyOTEsIm5iZiI6MTU4MTk1MTI5MSwiZXhwIjoxNTgxOTU4NDkxLCJpc3MiOiJodHRwOlwvXC9hcGkudGVjaGJiLmFwcCIsImF1ZCI6Imh0dHA6XC9cL2FwaS50ZWNoYmIuYXBwIn0.Ko30zY-T94Qhs_HwF8lgqGVoJmEkVq78-aQteOqqiWhx73HXmVHyMt5iJewxrSgdpLiTMB-qNoxhOKcTvh4b_zYL3QvgVjh9Hm9unDdiRAK4nQYsQ_Tx01UHeqQL8ZY5Y0yhzjU3VtrZ22PjVSAK6qIm1rXCs41bh36D0HB6d0k_CBnv7vbys6lIo6sF_t7o_QodFacb-wXy7Nj9TesW9dhjWnoj3tI3KhdbsTEFvup_3uIiXrSRC-w_XFdtteJfHXnrQjD3YF3MRHJWeRLRqCja8tq5Fop7JAU41i50NKP4MNIDeOs_Ls-t_XoLPqswfU2jB0YuVXCPR_9ZUnwPkAZNy9L_JkmecsQxfm4KIAZcirOJi_Ps6Uq-EcAaXIi2PxeXDPwaMx2_zTajsrpu_8MpzkKmuX_1Uj118QXesXv7sHxBCjoRQHjcroXFXm62QLABS1aiC6tqsarx0co_sjuRTaG_SOMnidG1hHomAZ9EMCv3-YGvxQ0YfXUAu3xZaHli0-WRPKnn2p5CKPakWHRvifstBvDV8MK10A1YkceI_5YI-eywoaVqrrBwWdTNgvrXq2kpDbooxuE1w7_qgt2WK85aVHBdGyIsT50Q6tyQ_oGLMaDZOGV3Rw2rRU-WLcKiK0-5gz8E8atd6Y_4B5WOtZJjyjxnru0haD5keLA"
 expires: 120
 type: "Bearer"
 payload:
 name: "Dusan"
 surname: "Malusev"
 email: "malusevd99@gmail.com"
 role: "admin"
 */


export interface AuthSuccessPayload {
  token: string;
  expires: number;
  type: 'Bearer';
  payload: User;
}

export interface AuthError {

}
