# security-plugin
```
    /**
     * @GetMapping("/login")
     */
    public function login() {
        $principal = new Principal();
        $principal->setUsername('elite');
        $principal->addRole('role1');
        $principal->addPermissions('p1');
        $principal->addPermissions('p2');
        $this->setPrincipal($principal);
        return 'success';
    }
    
    /**
     * @PreAuthorize()
     * @GetMapping()
     */
    public function auth1()
    {
        return '必须先访问/login';
    }
    
    /**
     * @PreAuthorize(all=true, deny=true)
     * @GetMapping()
     */
    public function auth2()
    {
        return '必须先访问/login';
    }
    
    /**
     * @PreAuthorize("p1")
     * @GetMapping()
     */
    public function auth3()
    {
        return '必须有p1权限';
    }
    
    /**
     * @PreAuthorize(value="p1", roles={"role1", "role2"}, ips={"172.21.0.0/16"})
     * @GetMapping("/auth4")
     */
    public function auth4()
    {
        return '必须有p1权限，role1或role2,ip掩码地址才可以访问';
    }
```
