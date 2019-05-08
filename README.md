# security-plugin
```
/**
 * 当前账户有指定角色时返回true
 * @param string $role
 * @return bool
 */
function hasRole(string $role)

/**
 * 当前账户有指定角色中的任意一个时返回true
 * @param array $roles
 * @return bool
 */
function hasAnyRole(array $roles)

/**
 * 允许所有
 * @return bool
 */
function permitAll()

/**
 * 拒绝所有
 * @return bool
 */
function denyAll()

/**
 * 是否已经登录
 */
function isAuthenticated()

/**
 * 是否拥有权限
 * @param string $permission
 * @return bool
 */
function hasPermission(string $permission)

/**
 * IP地址是否符合支持10.0.0.0/16这种
 * @param array $ips
 * @return bool
 */
function hasIpAddress($ips)
```
