/* ====================================================================
 * The Apache Software License, Version 1.1
 *
 * Copyright (c) 2000-2002 The Apache Software Foundation.  All rights
 * reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 * 1. Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in
 *    the documentation and/or other materials provided with the
 *    distribution.
 *
 * 3. The end-user documentation included with the redistribution,
 *    if any, must include the following acknowledgment:
 *       "This product includes software developed by the
 *        Apache Software Foundation (http://www.apache.org/)."
 *    Alternately, this acknowledgment may appear in the software itself,
 *    if and wherever such third-party acknowledgments normally appear.
 *
 * 4. The names "Apache" and "Apache Software Foundation" must
 *    not be used to endorse or promote products derived from this
 *    software without prior written permission. For written
 *    permission, please contact apache@apache.org.
 *
 * 5. Products derived from this software may not be called "Apache",
 *    "mod_python", or "modpython", nor may these terms appear in their
 *    name, without prior written permission of the Apache Software
 *    Foundation.
 *
 * THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESSED OR IMPLIED
 * WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
 * OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED.  IN NO EVENT SHALL THE APACHE SOFTWARE FOUNDATION OR
 * ITS CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF
 * USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT
 * OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 * ====================================================================
 *
 * This software consists of voluntary contributions made by many
 * individuals on behalf of the Apache Software Foundation.  For more
 * information on the Apache Software Foundation, please see
 * <http://www.apache.org/>.
 *
 * Originally developed by Gregory Trubetskoy <grisha@apache.org>
 *
 *
 * serverobject.c 
 *
 * $Id: serverobject.c,v 1.12 2002/09/12 18:24:06 gstein Exp $
 *
 */

#include "mod_python.h"


/**
 **     MpServer_FromServer
 **
 *      This routine creates a Python serverobject given an Apache
 *      server_rec pointer.
 *
 */

PyObject * MpServer_FromServer(server_rec *s)
{
    serverobject *result;

    result = PyMem_NEW(serverobject, 1);
    if (! result)
	return PyErr_NoMemory();

    result->server = s;
    result->ob_type = &MpServer_Type;
    result->next = NULL;

    _Py_NewReference(result);
    return (PyObject *)result;
}

/**
 ** server.get_config(server self)
 **
 *     Returns the config directives set through Python* apache directives.
 *     unlike req.get_config, this one returns the per-server config
 */

static PyObject * server_get_config(serverobject *self)
{
    py_config *conf =
        (py_config *) ap_get_module_config(self->server->module_config, 
                                           &python_module);
    return MpTable_FromTable(conf->directives);
}

/**
 ** server.register_cleanup(req, handler, data)
 **
 *    same as request.register_cleanup, except the server pool is used.
 *    the server pool gets destroyed before the child dies or when the
 *    whole process dies in multithreaded situations.
 */

static PyObject *server_register_cleanup(serverobject *self, PyObject *args)
{

    cleanup_info *ci;
    PyObject *handler = NULL;
    PyObject *data = NULL;
    PyObject *Req = NULL;
    requestobject *req = NULL;

    if (! PyArg_ParseTuple(args, "OO|O", &Req, &handler, &data))
	return NULL; 

    if (! PyObject_HasAttrString(Req, "_req")) {
	PyErr_SetString(PyExc_ValueError, "first argument must be a Request object");
	return NULL;
    }
    else {

	req = (requestobject *) PyObject_GetAttrString(Req, "_req");

	if (! MpRequest_Check(req)) {
	    PyErr_SetString(PyExc_ValueError, 
			    "first argument must be a request object");
	    return NULL;
	}
	else if(!PyCallable_Check(handler)) {
	    PyErr_SetString(PyExc_ValueError, 
			    "second argument must be a callable object");
	    return NULL;
	}
    }
    
    ci = (cleanup_info *)malloc(sizeof(cleanup_info));
    ci->request_rec = NULL;
    ci->server_rec = self->server;
    Py_INCREF(handler);
    ci->handler = handler;
    ci->interpreter = req->interpreter;
    if (data) {
	Py_INCREF(data);
	ci->data = data;
    }
    else {
	Py_INCREF(Py_None);
	ci->data = Py_None;
    }
    
    apr_pool_cleanup_register(child_init_pool, ci, python_cleanup, 
			      apr_pool_cleanup_null);
    
    Py_INCREF(Py_None);
    return Py_None;
}

static PyMethodDef serverobjectmethods[] = {
    {"get_config",           (PyCFunction) server_get_config,        METH_NOARGS},
    {"register_cleanup",     (PyCFunction) server_register_cleanup,  METH_VARARGS},
    { NULL, NULL } /* sentinel */
};

#define OFF(x) offsetof(server_rec, x)

static struct memberlist server_memberlist[] = {
    /* XXX process */
    /* next ? */
    {"defn_name",          T_STRING,    OFF(defn_name),          RO},
    {"defn_line_number",   T_INT,       OFF(defn_line_number),   RO},
    {"server_admin",       T_STRING,    OFF(server_admin),       RO},
    {"server_hostname",    T_STRING,    OFF(server_hostname),    RO},
    {"port",               T_SHORT,     OFF(port),               RO},
    {"error_fname",        T_STRING,    OFF(error_fname),        RO},
    {"loglevel",           T_INT,       OFF(loglevel),           RO},
    {"is_virtual",         T_INT,       OFF(is_virtual),         RO},
    /* XXX implement module_config ? */
    /* XXX implement lookup_defaults ? */
    /* XXX implement server_addr_rec ? */
    {"timeout",            T_INT,       OFF(timeout),            RO},
    {"keep_alive_timeout", T_INT,       OFF(keep_alive_timeout), RO},
    {"keep_alive_max",     T_INT,       OFF(keep_alive_max),     RO},
    {"keep_alive",         T_INT,       OFF(keep_alive),         RO},
    /* XXX send_buffer_size gone. where? document */
    //{"send_buffer_size",   T_INT,       OFF(send_buffer_size),   RO},
    {"path",               T_STRING,    OFF(path),               RO},
    {"pathlen",            T_INT,       OFF(pathlen),            RO},
    /* XXX names */
    /* XXX wild names */
    /* XXX server_uid and server_gid seem gone. Where? Document. */
    //{"server_uid",         T_INT,       OFF(server_uid),         RO},
    //{"server_gid",         T_INT,       OFF(server_gid),         RO},
    /* XXX Document limit* below. Make RW? */
    {"limit_req_line",       T_INT,       OFF(limit_req_line),     RO},
    {"limit_req_fieldsize",  T_INT,       OFF(limit_req_fieldsize),RO},
    {"limit_req_fields",     T_INT,       OFF(limit_req_fields),   RO},
    {NULL}  /* Sentinel */
};

/**
 ** server_dealloc
 **
 *
 */

static void server_dealloc(serverobject *self)
{  

    Py_XDECREF(self->next);
    free(self);
}

/**
 ** server_getattr
 **
 *  Get server object attributes
 *
 *
 */

static PyObject * server_getattr(serverobject *self, char *name)
{

    PyObject *res;

    res = Py_FindMethod(serverobjectmethods, (PyObject *)self, name);
    if (res != NULL)
	return res;
    
    PyErr_Clear();

    if (strcmp(name, "next") == 0)
	/* server.next serverobject is created as needed */
	if (self->next == NULL) {
	    if (self->server->next == NULL) {
		Py_INCREF(Py_None);
		return Py_None;
	    }
	    else {
		self->next = MpServer_FromServer(self->server->next);
		Py_INCREF(self->next);
		return self->next;
	    }
	}
	else {
	    Py_INCREF(self->next);
	    return self->next;
	}

    else if (strcmp(name, "error_log") == 0) {
	return PyInt_FromLong((long)fileno((FILE *)self->server->error_log));
    }
    else if (strcmp(name, "names") == 0) {
	return tuple_from_array_header(self->server->names);
    }
    else if (strcmp(name, "wild_names") == 0) {
	return tuple_from_array_header(self->server->wild_names);
    }
    else if (strcmp(name, "my_generation") == 0) {
	return PyInt_FromLong((long)ap_my_generation);
    }
    else if (strcmp(name, "restart_time") == 0) {
      return PyInt_FromLong((long)ap_scoreboard_image->global->restart_time);
    }
    else
	return PyMember_Get((char *)self->server, server_memberlist, name);

}

PyTypeObject MpServer_Type = {
    PyObject_HEAD_INIT(NULL)
    0,
    "mp_server",
    sizeof(serverobject),
    0,
    (destructor) server_dealloc,     /*tp_dealloc*/
    0,                               /*tp_print*/
    (getattrfunc) server_getattr,    /*tp_getattr*/
    0,                               /*tp_setattr*/
    0,                               /*tp_compare*/
    0,                               /*tp_repr*/
    0,                               /*tp_as_number*/
    0,                               /*tp_as_sequence*/
    0,                               /*tp_as_mapping*/
    0,                               /*tp_hash*/
};




